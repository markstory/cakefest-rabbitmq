<?php

class LogShell extends Shell {

	public $uses = array('PageView');

	public function main() {
		$data = json_decode($this->args[0]);
		$this->PageView->create();
		if ($this->PageView->save($data)) {
			$this->out('Saved pageview', 1, Shell::NORMAL);
			return 0;
		}
		return 1;
	}
}
