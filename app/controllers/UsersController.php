<?php

class UsersController extends BaseController {
    public function indexAction() {
        $this->tag->prependTitle('ログイン | ');
    }

    public function loginAction() {
        $password = $this->request->getPost('pass');
        $user = Users::findFirstByName($this->config->application->adminUser);

        if ($user) {
            if ($this->security->checkHash($password, $user->password)) {
                $this->session->set('user', $user->name);
                $this->flashSession->notice('管理者としてログインしました。投稿の編集・削除ができます。');

                return $this->response->redirect('posts');
            }
        }

        $this->flashSession->error('ログインに失敗しました。');

        // Forward to the login form again.
        return $this->dispatcher->forward(array(
            'controller' => 'users',
            'action' => 'index',
        ));
    }

    public function logoutAction() {
        // Remove a session variable
        $this->session->remove('user');

        // Destroy the whole session
        // $this->session->destroy();

        $this->flashSession->notice('ログアウトしました。');

        return $this->response->redirect('posts');
    }
}
