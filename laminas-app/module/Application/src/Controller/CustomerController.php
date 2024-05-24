<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\CustomerTable;

class CustomerController extends AbstractActionController
{
    private $table;

    public function __construct(CustomerTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'customers' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $customer = new Customer();
            $customer->exchangeArray($data);
            $this->table->saveCustomer($customer);

            return $this->redirect()->toRoute('customer');
        }

        return new ViewModel();
    }
}
