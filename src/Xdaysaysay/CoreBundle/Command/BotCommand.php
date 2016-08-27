<?php

namespace Xdaysaysay\CoreBundle\Command;

use Phergie\Irc\Client\React\Client;
use Phergie\Irc\Client\React\WriteStream;
use Phergie\Irc\Connection;
use Phergie\Irc\ConnectionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xdaysaysay\CoreBundle\Entity\IRCServer;
use Xdaysaysay\CoreBundle\Entity\Team;

class BotCommand extends ContainerAwareCommand
{
    private static $ircServers = [];

    /**
     * @inheritdoc
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('xdaysaysay:bot')
            ->setDescription('Bot commands')
            ->addArgument(
                'option',
                InputArgument::REQUIRED,
                'start|stop|restart|status'
            );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $option = $input->getArgument('option');
        switch ($option) {
            case 'start':
                $this->start($output);
                break;
            case 'stop':
                break;
            case 'restart':
                break;
            case 'status':
                break;
        }
    }

    private function initializeServers()
    {
        $ircServers = $this->getContainer()->get('doctrine')->getRepository('XdaysaysayCoreBundle:IRCServer')->findAll();
        foreach ($ircServers as $ircServer) {
            $teams = [];
            if (!$ircServer->getXdccnames()->isEmpty()) {
                foreach ($ircServer->getXdccnames() as $xdccName) {
                    if ($xdccName->getXdcc()->getVisible()) {
                        foreach ($ircServer->getTeams() as $team) {
                            $teams[] = $team;
                        }
                        if (empty(self::$ircServers[$ircServer->getHost()])) {
                            self::$ircServers[$ircServer->getHost()] = ['ircServer' => $xdccName->getIrcServer(), 'status' => 'offline'];
                        }
                    }
                }
            }
            if (!empty(self::$ircServers[$ircServer->getHost()])) {
                self::$ircServers[$ircServer->getHost()]['teams'] = $teams;
            }
        }
    }

    private function start(OutputInterface $output)
    {
        $this->initializeServers();
        // Test
        self::$ircServers = [];
        $ircServer = $this->getContainer()->get('doctrine')->getRepository('XdaysaysayCoreBundle:IRCServer')->find(7);
        $team = $this->getContainer()->get('doctrine')->getRepository('XdaysaysayCoreBundle:Team')->find(26);
        self::$ircServers[$ircServer->getHost()] = ['ircServer' => $ircServer, 'status' => 'offline', 'teams' => [$team]]; // Otaku-IRC
        // End Test
        foreach (self::$ircServers as $ircServer) {
            if ($ircServer['status'] === 'offline') {
                $this->startBot($output, $ircServer['ircServer']);
            }
        }
    }

    private function startBot(OutputInterface $output, IRCServer $ircServer)
    {
        $connection = new Connection();

        $connection
            ->setServerHostname($ircServer->getHost())
            ->setNickname('xdaysaysay')
            ->setUsername('xdaysaysay')
            ->setHostname('xdaysaysay')
            ->setRealname('xdaysaysay')
            ->setOption('write', new WriteStream());
        if ($ircServer->getPortSsl()) {
            $connection->setOption('transport', 'ssl');
            $connection->setServerPort($ircServer->getPortSsl());
        } else {
            $connection->setServerPort($ircServer->getPort());
        }

        $output->writeln('Connection to '.$connection->getServerHostname());

        $client = new Client();

        $client->on('irc.received', function ($message, WriteStream $write, Connection $connection, LoggerInterface $logger) {
            if ($message['command'] !== 'JOIN') {
                return;
            }
            $channel = $message['params']['channels'];
            $nick = $message['nick'];
            $write->ircPrivmsg($channel, 'Welcome '.$nick.'!');
        });

        $client->on('connect.after.each', function (Connection $connection, WriteStream $write) use ($output, $client) {
            $output->writeln('Connected to '.$connection->getServerHostname());
            if ($write) {
                /** @var Team $team */
                foreach (self::$ircServers[$connection->getServerHostname()]['teams'] as $team) {
                    $client->addTimer(15, function() use($write, $team) {
                        $join = $write->ircJoin($team->getChanNameStaff(), $team->getChanNameStaffPassword() ? : null);
                        dump($join);
                        $join = $write->ircJoin($team->getChanName(), $team->getChanNamePassword() ? : null);
                        dump($join);
                    });
                }
            }
        });

        $client->on('connect.error', function (\Exception $exception, ConnectionInterface $connection, LoggerInterface $logger) {
            dump('connect.error');
            $logger->debug('Connection to '.$connection->getServerHostname().' lost: '.$exception->getMessage());
        });
//        $client->setTickInterval()
        $client->run($connection);
    }
}