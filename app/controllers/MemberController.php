<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class MemberController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for Member
     */
    public function searchAction($params=null)
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Member', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            if (isset($params)) {
                $query = Criteria::fromInput($this->di, 'Member', $params);
                $this->persistent->parameters = $query->getParams();
            } else {
                $numberPage = $this->request->getQuery("page", "int");
            }
        }


        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $member = Member::find($parameters);
        if (count($member) == 0) {
            $this->flash->notice("The search did not find any Member");

            $this->dispatcher->forward([
                "controller" => "Member",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $member,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a Member
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $member = Member::findFirstByid($id);
            if (!$member) {
                $this->flash->error("Member was not found");

                $this->dispatcher->forward([
                    'controller' => "Member",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $member->getId();

            $this->tag->setDefault("id", $member->getId());
            $this->tag->setDefault("firstname", $member->getFirstname());
            $this->tag->setDefault("surname", $member->getSurname());
            $this->tag->setDefault("membertype", $member->getMembertype());
            $this->tag->setDefault("dateofbirth", $member->getDateofbirth());
            $this->view->memberImages = $member->getMemberimage();


        }
    }

    /**
     * Creates a new Member
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "Member",
                'action' => 'index'
            ]);

            return;
        }

        $member = new Member();
        $member->setfirstname($this->request->getPost("firstname"));
        $member->setsurname($this->request->getPost("surname"));
        $member->setmembertype($this->request->getPost("membertype"));
        $member->setdateofbirth($this->request->getPost("dateofbirth"));
        $member->setMemberPic(base64_encode(file_get_contents($this->request->getUploadedFiles()[0]->getTempName())));
        

        if (!$member->save()) {
            foreach ($member->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Member",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Member was created successfully");

        $this->dispatcher->forward([
            'controller' => "Member",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a Member edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "Member",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $member = Member::findFirstByid($id);

        $this->view->memberImages = $member->getMemberimage();

        if (!$member) {
            $this->flash->error("Member does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "Member",
                'action' => 'index'
            ]);

            return;
        }

        $member->setfirstname($this->request->getPost("firstname"));
        $member->setsurname($this->request->getPost("surname"));
        $member->setmembertype($this->request->getPost("membertype"));
        $member->setdateofbirth($this->request->getPost("dateofbirth"));
        

        if (!$member->save()) {

            foreach ($member->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Member",
                'action' => 'edit',
                'params' => [$member->getId()]
            ]);

            return;
        }

        $this->flash->success("Member was updated successfully");

        $this->dispatcher->forward([
            'controller' => "Member",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a Member
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $member = Member::findFirstByid($id);
        if (!$member) {
            $this->flash->error("Member was not found");

            $this->dispatcher->forward([
                'controller' => "Member",
                'action' => 'index'
            ]);

            return;
        }

        if (!$member->delete()) {

            foreach ($member->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Member",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Member was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "Member",
            'action' => "index"
        ]);
    }

}
