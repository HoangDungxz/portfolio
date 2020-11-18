<?php
namespace AHT\Portfolio\Block\Adminhtml\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $_wysiwygConfig;
    protected $_systemStore;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    )
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('post__form');
        $this->setTitle(__('Information'));
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('portfolio_post');

        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype' => 'multipart/form-data']]
        );


        $fieldset = $form->addFieldset('add_post_form', ['legend' => __('Portfolio')]);
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }



        $fieldset->addField(
            'title',
            'text',
            [
                'label' => __('Title'),
                'name' => 'title',
                'required' => true,
                'value' => $model->getTitle()
            ]
        );


        $fieldset->addField(
           'images',
           'image',
           [
            'name' => 'Images',
            'label' => __('My Image'),
            'title' => __('My Image'),
            'class' => 'custom_image',
            'data-form-part' => $this->getData('target_form'),
            'value' => 'portfolio/images/'.$model->getImages(),
            'note' => __('Allowed image types: jpg,png')
        ]
    );


        $fieldset->addField(
            'description',
            'text',
            [
                'label' => __('Description'),
                'name' => 'description',
                'required' => true,
                'value' => $model->getDescription()
            ]
        );        

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}