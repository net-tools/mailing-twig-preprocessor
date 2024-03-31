<?php

// namespace
namespace Nettools\MassMailing\TemplateEngine;





/**
 * Helper class to send an email whose content is rendered with Twig
 */
class Twig implements PreProcessor
{
	protected $twigTemplate = NULL;
	protected $cache = NULL;

	
	
	/**
	 * Create twig object at first call (we need the text content, and it's not available when constructing object)
	 *
	 * @param string $template Twig template (in fact, the email string content that may have Twig/Markdown tags)
	 * @return Twig\TemplateWrapper
	 * @throws \Nettools\MassMailing\TemplateEngine\Exception
	 */
	protected function getTwigTemplate($template)
	{
		// if template already compiled, return it
		if ( $this->twigTemplate )
			return $this->twigTemplate;
			
		
		// otherwise, creating twig template
		try
		{
			$twig = uniqid();
			$loader = new \Twig\Loader\ArrayLoader([$twig => $template]);
			$twigenv = new \Twig\Environment($loader, array(
				'cache' => $this->cache,
				'strict_variables' => true,
				'auto_reload'=>true
			));


			$this->twigTemplate = $twigenv->load($twig);
			return $this->twigTemplate;
		}
		catch(\Exception $e)
		{
			throw new \Nettools\MassMailing\TemplateEngine\Exception('Twig loading issue : ' . $e->getMessage());
		}
	}
	
	
	
	/**
	 * Constructor
	 *
	 * @param string $cache If set, path to twig cache as a string
	 */
	function __construct($cache = NULL)
	{
		// cache path
		if ( is_null($cache) )
			$this->cache = sys_get_temp_dir();
		else
			$this->cache = $cache;
		
		
	}
	
	

	/**
	 * Process email Twig template
	 *
	 * @param string $txt The text content to process
	 * @param mixed $data Any data required to update the text content
	 * @return string
	 * @throws \Nettools\MassMailing\TemplateEngine\Exception
	 */
	public function process($txt, $data = NULL)
	{
		try
		{
			return $this->getTwigTemplate($txt)->render($data);
		}
		catch(\Throwable $e)
		{
			throw new \Nettools\MassMailing\TemplateEngine\Exception('Twig rendering issue : ' . $e->getMessage());
		}
	}
}


?>