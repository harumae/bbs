<?php

class PostsController extends BaseController {
    public function indexAction($page = 1) {
        $posts = Posts::find(array(
            'is_deleted = 0',
            'order' => 'id desc',
        ));

        $page = $this->filter->sanitize($page, 'int');

        $this->tag->prependTitle($page . ' ページ目 | ');

        $paginator = new Phalcon\Paginator\Adapter\Model(array(
            'data'  => $posts,
            'limit' => $this->config->application->postPerPage,
            'page'  => $page,
        ));

        $this->view->page = $paginator->getPaginate();

        if ($this->session->has('user') &&
            $this->session->get('user') === $this->config->application->adminUser) {
            $this->view->logged_in = true;
        }

        if ($this->cookies->has($this->config->cookie->name)) {
            $cookies = $this->cookies->get($this->config->cookie->name);
            $cookieValue = explode(',', $cookies->getValue());
            /**
             * デフォルトでクッキーはクライアントへの送信前に自動的に暗号化され、
             * 取り出し時に復号化されるが、暗号化時にデータが規定のブロックサイズの
             * 倍数に満たない場合に \0 (null) でパディングされるため、復号化後に
             * パディングを取り除いておく。
             */
            $this->view->cookie = array(
                'name' => trim($cookieValue[0]),
                'email' => trim($cookieValue[1]),
            );
        }
    }

    public function newAction() {
        $title = $this->request->getPost('title');
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email', 'email');
        $comment = $this->request->getPost('comment');

        if ($this->request->hasFiles()) {
            $images = new Images();
            $files = $this->request->getUploadedFiles();
            $images->file = $files[0];

            if ($images->create()) {
                $lastId = $images->id;
            }
        }

        $posts = new Posts();

        // Fills columns value.
        $posts->title = $title;
        $posts->name = $name;
        $posts->email = $email;
        $posts->comment = $comment;

        // Set image_id if an uploaded file exists.
        if (isset($lastId)) {
            $posts->image_id = $lastId;
        }

        if ($posts->create()) {
            $this->flashSession->success('投稿しました。');
        } else {
            foreach ($posts->getMessages() as $message) {
                $logMessage = sprintf(
                    '%s: %s',
                    $message->getField(),
                    $message->getMessage()
                );
                $this->logger->error($logMessage);
                $this->flashSession->error($message->getMessage());
            }
        }

        // Store name and email into cookie.
        $this->cookies->set(
            $this->config->cookie->name,
            $name . ',' . $email,
            time() + $this->config->cookie->expire
        );
        $this->cookies->send();

        return $this->response->redirect('posts');
    }

    public function editAction($id) {
        $this->tag->prependTitle('編集 | ');

        $id = $this->filter->sanitize($id, 'int');
        $posts = Posts::findFirstById($id);

        if ($this->request->isGet()) {
            $this->view->item = $posts;

            return;
        }

        if ($this->request->isPost()) {
            if ($this->request->hasFiles()) {
                $images = new Images();
                $files = $this->request->getUploadedFiles();
                $images->file = $files[0];

                if ($images->create()) {
                    $posts->image_id = $images->id;
                }
            }

            // Fills columns value.
            $posts->title = $this->request->getPost('title');
            $posts->name = $this->request->getPost('name');
            $posts->email = $this->request->getPost('email', 'email');
            $posts->comment = $this->request->getPost('comment');

            $delete = $this->request->getPost('delete');

            if ($delete === 'on') {
                $posts->image_id = null;
            }

            if ($posts->update()) {
                $this->flashSession->notice('更新しました。');
            } else {
                foreach ($posts->getMessages() as $message) {
                    $logMessage = sprintf(
                        '%s: %s',
                        $message->getField(),
                        $message->getMessage()
                    );
                    $this->logger->error($logMessage);
                    $this->flashSession->error($message->getMessage());
                }
            }

            return $this->response->redirect('posts');
        }
    }

    public function deleteAction($id) {
        $this->tag->prependTitle('削除 | ');

        $id = $this->filter->sanitize($id, 'int');
        $posts = Posts::findFirstById($id);

        if ($this->request->isGet()) {
            $this->view->item = $posts;

            return;
        }

        if ($this->request->isPost()) {
            $posts->is_deleted = 1;

            if ($posts->update()) {
                $this->flashSession->notice('削除しました。');
            } else {
                foreach ($posts->getMessages() as $message) {
                    $logMessage = sprintf(
                        '%s: %s',
                        $message->getField(),
                        $message->getMessage()
                    );
                    $this->logger->error($logMessage);
                }

                $this->flashSession->error('削除に失敗しました。');
            }

            return $this->response->redirect('posts');
        }
    }

    public function csvAction() {
        $columnMap = array(
            'id'            => '投稿ID',
            'registered_at' => '投稿日時',
            'updated_at'    => '更新日時',
            'title'         => 'タイトル',
            'name'          => '名前',
            'email'         => 'メールアドレス',
            'comment'       => 'コメント',
        );

        $lineStr = '';

        foreach ($columnMap as $key => $value) {
            $lineStr .= mb_convert_encoding($value, 'SJIS', 'UTF-8') . ',';
        }

        rtrim($lineStr, ',');

        $fileName = 'bbs_export_' . date('YmdHis') . '.csv';

        $this->response->setContentType('application/octet-stream');
        $this->response->setHeader(
            'Content-Disposition',
            'attachment; filename=' . $fileName
        );
        $this->response->appendContent($lineStr . "\n");

        $posts = Posts::find(array(
            'is_deleted = 0',
        ));

        foreach ($posts as $post) {
            $lineStr = '';

            foreach ($columnMap as $key => $value) {
                $lineStr .= '"' . mb_convert_encoding(addslashes($post->$key), 'SJIS', 'UTF-8') . '",';
            }

            rtrim($lineStr, ',');
            $this->response->appendContent($lineStr . "\n");
        }

        return $this->response;
    }
}
