<?php

namespace Orkestra\APCBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Orkestra\APCBundle\Cache\APC;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class APCClearCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setDefinition(array())
			->setName('apc:clear')
			->addOption('opcode', null, InputOption::VALUE_NONE, 'Clear only the opcode cache')
			->addOption('user', null, InputOption::VALUE_NONE, 'Clear only the user cache')
			->setHelp('Note: without options, both caches will be deleted')
			->setDescription('Delete APC opcode or user cache')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$clearOpcode	= 'false';
		$clearUser		= 'false';
		
		if (null != $input->getOption('opcode')) {
			$clearOpcode = 'true';
		}
		else if (null != $input->getOption('user')) {
			$clearUser = 'true';
		}
		else {
			$clearOpcode = 'true';
			$clearUser = 'true';
		}

		$password = $this->getContainer()->getParameter('orkestra_apc.access_password');
		$commandFile = $this->getContainer()->get('templating')->render('OrkestraAPCBundle:Command:clear.html.twig', array(
			'opcode'			=> $clearOpcode,
			'user'				=> $clearUser,
			'passwordNeeded'	=> 'null' != $password ? 'true': 'false',
			'password'			=> $password
		));

		$webDir = $this->getContainer()->getParameter('orkestra_apc.web_dir');
		$filename = md5(uniqid() . mt_rand(0, 9999999)) . '.php';
		
		file_put_contents($webDir . '/' . $filename, $commandFile);
		
		// TODO curl mode
		$jSonReturn = file_get_contents($this->getContainer()->getParameter('orkestra_apc.website_url') . '/' . $filename . ('null' != $password ? '?password=' . $password : ''));
		if (!@unlink($webDir . '/' . $filename)) {
			$output->writeln('Not allowed to remove temporary file named : ' . $filename . ' ! Please remove it manually !');
		}

		$return = json_decode($jSonReturn, true);
		switch ($return['code'] == -1) {
			case -1:
				$output->writeln('The password does not match, please check the config.yml APC options !');
			return;
			case 0:
				$output->writeln('The APC cache has been deleted successfully.');
			return;
			case 1:
				$output->writeln('The APC opcode cache can not be deleted.');
			return;
			case 2:
				$output->writeln('The APC user cache can not be deleted.');
			return;
			case 3:
				$output->writeln('The APC user and opcode cache can not be deleted.');
			return;

			default: break;
		}
	}
}