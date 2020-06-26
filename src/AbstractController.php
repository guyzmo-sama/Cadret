<?php
 
namespace Cadret;
 
abstract class AbstractController
{

    private $_session;

    private $_flashbag;

    private $templateEngine;

    public function __construct() 
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__, 4) . '/templates');
        $this->templateEngine = new \Twig\Environment($loader);
    }

    protected function render($view, $vars = [])
    {
        return $this->templateEngine->render(
            $view.'.html.twig', 
            array_merge(
                $vars,
                ['flashbag'     => (new FlashBag)->get()],
                ['session'      => $this->session()->get()],
                ['current_page' => $_SERVER['PATH_INFO']??'/']
            )
        );
    }

    protected function session()
    {
        if($this->_session === null) {
            $this->_session = new Session();
        }
        return $this->_session;
    }

    protected function flashbag()
    {
        if($this->_flashbag === null) {
            $this->_flashbag = new FlashBag();
        }
        return $this->_flashbag;
    }

    protected function redirectToRoute(string $url)
    {
        header("location:".$url);
        exit();
    }

    protected function isConnectedRedirect(string $url)
    {
        $user = $this->session()->get('user');
        if(is_array($user) && isset($user['id']) && $user['id'] > 0) 
        {
            $this->redirectToRoute($url);
        }
    }

    protected function isNotConnectedRedirect(string $url)
    {
        $user = $this->session()->get('user');
        if((is_array($user) && isset($user['id']) && $user['id'] > 0) !== true) 
        {
            $this->redirectToRoute($url);
        }
    }
}
