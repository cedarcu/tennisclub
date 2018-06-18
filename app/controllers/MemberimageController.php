<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class MemberimageController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for memberImage
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Memberimage', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $memberImage = Memberimage::find($parameters);
        if (count($memberImage) == 0) {
            $this->flash->notice("The search did not find any memberImage");

            $this->dispatcher->forward([
                "controller" => "memberImage",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $memberImage,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction($memberid)
    {
        $this->view->memberid = $memberid;
    }

    /**
     * Edits a memberImage
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $memberImage = Memberimage::findFirstByid($id);
            if (!$memberImage) {
                $this->flash->error("memberImage was not found");

                $this->dispatcher->forward([
                    'controller' => "memberImage",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $memberImage->getId();

            $this->tag->setDefault("id", $memberImage->getId());
            $this->tag->setDefault("memberid", $memberImage->getMemberid());
            $this->tag->setDefault("description", $memberImage->getDescription());
            $this->tag->setDefault("imagefile", $memberImage->getImagefile());
            
        }
    }

    /**
     * Creates a new memberImage
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(['controller' => "Memberimage",'action' => 'new']);
            return;
        }

        $mid = $this->request->getPost("memberid");
        if ($this->request->hasFiles() == true) {
            $i=0;
            foreach ($this->request->getUploadedFiles() as $file) {
                $image = new Memberimage();
                $image->setMemberid($mid);
                $image->setImagefile(base64_encode(file_get_contents($file->getTempName())));
                $image->setDescription($this->request->getPost("description")[$i++]);
                if (!$image->save()) {
                    foreach ($image->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }
        $this->dispatcher->forward(['controller' => "member",'action' => 'search']);
        return;
    }

    /**
     * Saves a memberImage edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "memberImage",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $memberImage = Memberimage::findFirstByid($id);

        if (!$memberImage) {
            $this->flash->error("memberImage does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "memberImage",
                'action' => 'index'
            ]);

            return;
        }

        $memberImage->setmemberid($this->request->getPost("memberid"));
        $memberImage->setdescription($this->request->getPost("description"));
        $memberImage->setimagefile($this->request->getPost("imagefile"));
        

        if (!$memberImage->save()) {

            foreach ($memberImage->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "memberImage",
                'action' => 'edit',
                'params' => [$memberImage->getId()]
            ]);

            return;
        }

        $this->flash->success("memberImage was updated successfully");

        $this->dispatcher->forward([
            'controller' => "memberImage",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a memberImage
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $memberImage = Memberimage::findFirstByid($id);
        if (!$memberImage) {
            $this->flash->error("memberImage was not found");

            $this->dispatcher->forward([
                'controller' => "memberImage",
                'action' => 'index'
            ]);

            return;
        }

        if (!$memberImage->delete()) {

            foreach ($memberImage->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "memberImage",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("memberImage was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "memberImage",
            'action' => "index"
        ]);
    }

}
