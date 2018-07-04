<?php
namespace OpenTechiz\Blog\Model\Post\Source;
class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{

    protected $post;

    public function __construct(\OpenTechiz\Blog\Model\Post $post)
    {
        $this->post = $post;
    }

    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->post->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}