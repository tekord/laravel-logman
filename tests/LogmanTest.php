<?php

namespace Tekord\Logman\Tests;

use PHPUnit\Framework\TestCase;
use Tekord\Logman\ContextContainer;

/**
 * @author Cyrill Tekord
 */
class LogmanTest extends TestCase {

	public function testPut() {
		$instance = new ContextContainer();

		$instance->put('one', 1);
		$instance->put('two', 2);
		$instance->put('null', null);

		$context = $instance->getContext();

		$this->assertEquals(1, $context['one']);
		$this->assertEquals(2, $context['two']);
		$this->assertEquals(null, $context['null']);
	}

	public function testPutWithOverwritingFlag() {
		$instance = new ContextContainer();

		$instance->put('one', 1);
		$instance->put('one', 50, false);

		$instance->put('two', 2, false);
		$instance->put('two', 60, false);

		$instance->put('three', 3, false);
		$instance->put('three', 70);

		$instance->put('null', null, false);
		$instance->put('null', 'i am alive', false);

		$context = $instance->getContext();

		$this->assertEquals(1, $context['one']);
		$this->assertEquals(2, $context['two']);
		$this->assertEquals(70, $context['three']);
		$this->assertEquals(null, $context['null']);
	}

	public function testPutIfPresented() {
		$instance = new ContextContainer();

		$instance->putIfPresented('one', 1);
		$instance->putIfPresented('two', 2);
		$instance->putIfPresented('null', null);
		$instance->putIfPresented('zero', 0);

		$context = $instance->getContext();

		$this->assertEquals(1, $context['one']);
		$this->assertEquals(2, $context['two']);
		$this->assertArrayNotHasKey('null', $context);
		$this->assertEquals(0, $context['zero']);
	}
}
