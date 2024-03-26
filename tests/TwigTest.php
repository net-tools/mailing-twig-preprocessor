<?php 

namespace Nettools\Mailing\MassMailing\Tests;



use \Nettools\Mailing\Mailer;
use \Nettools\Mailing\MassMailing\Twig;
use \Nettools\Mailing\MassMailing\Engine;




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