<?php

namespace AppBundle\Validator;

use FileUpload\Validator\Simple;

/**
 * Class SimpleFileUpload
 * @package AppBundle\Validator
 */
class SimpleFileUpload extends Simple
{
    /**
     * Merge (overwrite) default messages
     * @param array $new_messages
     */
    public function setMessages(array $new_messages)
    {
        $this->messages = $new_messages + $this->messages;
    }
}