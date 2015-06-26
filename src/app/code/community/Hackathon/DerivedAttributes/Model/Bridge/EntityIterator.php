<?php
use Hackathon\DerivedAttributes\BridgeInterface\EntityIteratorInterface;
use Hackathon\DerivedAttributes\Store;

class Hackathon_DerivedAttributes_Model_Bridge_EntityIterator implements EntityIteratorInterface
{
    /**
     * @var Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    protected $_collection;
    /**
     * @var Iterator
     */
    protected $_iterator;
    /**
     * @var int Iteration counter
     */
    protected $_iteration;
    /**
     * @var Store
     */
    protected $_store;
    /**
     * @var int Iteration counter offset for chunking
     */
    protected $_iterationOffset = 0;

    public function __construct(Varien_Data_Collection_Db $collection)
    {
        $this->_collection = $collection;
    }

    /**
     * @param $offset
     */
    public function setIterationOffset($offset)
    {
        $this->_iterationOffset = $offset;
    }

    /**
     * Returns total size of collection
     *
     * @return mixed
     */
    function getSize()
    {
        return $this->_collection->getSize();
    }

    function getStore()
    {
        return $this->_store;
    }

    function setStore(Store $store)
    {
        $this->_store = $store;
    }

    public function current()
    {
        $data = $this->_iterator->current()->getData();
        $data['store_id'] = (string) $this->_store;
        return $data;
    }

    public function next()
    {
        $this->_iteration++;
        $this->_iterator->next();
    }

    public function key()
    {
        return $this->_iteration + $this->_iterationOffset;
    }

    public function valid()
    {
        return $this->_iterator->valid();
    }

    public function rewind()
    {
        $this->_collection->clear()
            ->setStoreId((string) $this->_store)
            ->load();
        //TODO: load all ids, then chunk
        $this->_iteration = 0;
        $this->_iterator = $this->_collection->getIterator();
    }

}