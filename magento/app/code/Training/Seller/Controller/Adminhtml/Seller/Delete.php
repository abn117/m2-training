<?php


namespace Training\Seller\Controller\Adminhtml\Seller;

class Delete extends \Training\Seller\Controller\Adminhtml\Seller
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('seller_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Training\Seller\Model\Seller::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Seller.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['seller_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Seller to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
