<?php
use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    /**
     * 用户登录页
     */
    public  function loginAction()
    {
        if ($this->request->isPost() == true)
        {
            if($this->security->checkToken())
            {
                $username = $this->request->getPost('username');
                $password = trim($this->request->getPost('password'));

                $isUser = SunUser::findFirst("username = '$username' ");

                if($isUser)
                {
                    if( $this->security->checkHash($password,$isUser->password_hash) )
                    {
                        $this->cookies->set('username', $username, time() +  3600);

                        $this->response->redirect('?_url=/index/index');
                    }
                    else
                    {
                        //密码错误
                        $this->response->redirect('?_url=/login/index');
                    }
                }
                else
                {
                    //不存在该用户
                    $this->response->redirect('?_url=/login/index');
                }
            }
            else
            {
                $this->response->setStatusCode(404, "Not Found");
            }
        }
        else
        {
            $this->response->setStatusCode(404, "Not Found");
        }
    }

    public function logoutAction()
    {
        $this->cookies->set('username',FALSE);
        $this->response->redirect('?_url=/login/index');
    }






}




