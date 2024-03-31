<?php 

namespace Nettools\MassMailing\TemplateEngine\Tests;



use \Nettools\Mailing\Mailer;
use \Nettools\MassMailing\TemplateEngine\Twig;
use \Nettools\MassMailing\TemplateEngine\Engine;




class TwigTest extends \PHPUnit\Framework\TestCase
{
	public function testTwigPreprocessor()
	{
		$e = (new Engine())->template()
					->text('User name is `{{ name }}`')
					->noAlternatePart()
					->preProcessors([new Twig()])
					->withData([ 'name' => 'John Doe' ]);

		$mail = $e->build();
		$this->assertEquals(true, $mail instanceof \Nettools\Mailing\MailBuilder\TextPlainContent);
		$this->assertStringContainsString('User name is `John Doe`', $mail->getContent());
	}
}


?>