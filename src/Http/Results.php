<?php 

namespace Mchljams\Chicagotransit\Http;

use Mchljams\Chicagotransit\Entities\Entity;

class Results implements \IteratorAggregate
{

	private $items = [];

	// constructor
	public function __construct() {
	}
	
	// return iterator
	public function getIterator() {
		return new \ArrayIterator( $this->items );
	}

	public function add(Entity $item){
		$this->items[] = $item;
	}

}