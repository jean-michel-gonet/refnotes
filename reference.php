<?php

/**
 * Plugin RefNotes: Reference
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Mykola Ostrovskyy <spambox03@mail.ru>
 */

////////////////////////////////////////////////////////////////////////////////////////////////////
class refnotes_reference_mock {

    private $note;

    /**
     * Constructor
     */
    public function __construct($note) {
        $this->note = $note;
    }

    /**
     *
     */
    public function getNote() {
        return $this->note;
    }

    /**
     *
     */
    public function render() {
        return '';
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////
class refnotes_reference {

    private $inline;
    private $hidden;
    private $data;
    private $scope;
    private $note;
    private $id;

    /**
     * Constructor
     */
    public function __construct($scope, $note, $attributes, $data) {
        $this->inline = isset($attributes['inline']) ? $attributes['inline'] : false;
        $this->hidden = isset($attributes['hidden']) ? $attributes['hidden'] : false;
        $this->data = $data;
        $this->scope = $scope;
        $this->note = $note;
        $this->id = -1;

        if ($this->isBackReferenced()) {
            $this->id = $scope->getReferenceId();
        }
    }

    /**
     *
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     */
    public function getData() {
        return $this->data;
    }

    /**
    *
    */
    public function getNote() {
        return $this->note;
    }

    /**
    *
    */
    public function isInline() {
        return $this->inline;
    }

    /**
    *
    */
    public function isBackReferenced() {
        return !$this->inline && !$this->hidden;
    }

    /**
     *
     */
    public function getAnchorName() {
        $result = 'refnotes';
        $result .= $this->scope->getName();
        $result .= ':ref' . $this->id;

        return $result;
    }

    /**
     *
     */
    public function render() {
        $html = '';

        if (!$this->hidden) {
            if ($this->inline) {
                $html = '<sup>' . $this->note->getText() . '</sup>';
            }
            else {
                $html = $this->scope->getRenderer()->renderReference($this);
            }
        }

        return $html;
    }
}
