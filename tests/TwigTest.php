<?php 

namespace Nettools\MassMailing\MailingEngine\Tests;



use \Nettools\Mailing\Mailer;
use \Nettools\MassMailing\MailingEngine\Twig;
use \Nettools\MassMailing\MailingEngine\Engine;




class TwigTest extends \PHPUnit\Framework\TestCase
{
	public function testMSH()
	{
    	$ms = new \Nettools\Mailing\MailSenders\Virtual();
		$ml = new Mailer($ms);
		$msh = new Engine($ml, 'msh content #{{ name }}#', 'text/plain', 'unit-test@php.com', 'test subject', ['preProcessors' => array(new Twig())]);

		$msh->prepareAndSend('recipient@here.com', NULL, ['name' => 'me !']);
		
		$this->assertEquals(1, count($ms->getSent()));
		$this->assertEquals(true, is_int(strpos($ms->getSent()[0], 'msh content #me !#')));
	}
}


?>