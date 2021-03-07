<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Controller\Adminhtml\Discount;

use AndriiShkrebtii\RegularCustomer\Model\Authorization;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Edit extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST_EDIT;

    private \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    private \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    /**
     * Edit constructor.
     * @param \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $discountRequest = $this->discountRequestFactory->create();

        if ($discountRequestId = (int) $this->getRequest()->getParam('customer_request_id')) {
            $this->discountRequestResource->load($discountRequest, $discountRequestId);

            if (!$discountRequest->getId()) {
                $this->messageManager->addErrorMessage(__('This request no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(
            $discountRequest->getId() ? __('Edit Discount Request') : __('New Discount Request')
        );

        return $resultPage;
    }
}
