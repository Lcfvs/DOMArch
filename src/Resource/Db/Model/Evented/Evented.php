<?php
namespace DOMArch\Resource\Db\Model;

class Evented extends \DOMArch\Resource\Db\Model
{
    private function _validateTag($name) {
        $constant = get_called_class() . '::TAG_' . $name;

        if (!defined($constant)) {
            throw new Exception('Invalid tag ' . $constant);
        }
    }
    
    public function addTag($name, User $author, User $dest, $description = null) {
        $this->_validateTag($name);
        
        Tag::one()
            ->setClassName(get_called_class())
            ->setId($this->getId())
            ->setAuthor($author)
            ->setDest($dest)
            ->setName($name)
            ->setDescription($description)
            ->save();

        return $this;
    }
    
    public function hasTag($name) {
        $this->_validateTag($name);

        return (bool) Tag::count([
            'className' => get_called_class(),
            'id' => $this->getId(),
            'name' => $name
        ]);
    }

    public function getTag($name) {
        $this->_validateTag($name);

        return Tag::one([
            'className' => get_called_class(),
            'id' => $this->getId(),
            'name' => $name
        ]);
    }

    public function getTags() {
        return Tag::all([
            'className' => get_called_class(),
            'id' => $this->getId()
        ]);
    }

    public function archiveTag($name) {
        $this->_validateTag($name);

        return Tag::one([
            'className' => get_called_class(),
            'id' => $this->getId(),
            'name' => $name
        ]);
    }
}