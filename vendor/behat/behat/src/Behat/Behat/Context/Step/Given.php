<?php

namespace Behat\Behat\Context\Step;

use Behat\Gherkin\Node\StepNode;

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Given substep.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class Given implements SubstepInterface
{
    private $node;

    /**
     * Initializes Given substep.
     */
    public function __construct()
    {
        $arguments = func_get_args();

        $text = array_shift($arguments);
        $node = new StepNode('Given', $text);
        $node->setArguments($arguments);

        $this->node = $node;
    }

    /**
     * Returns substep node.
     *
     * @return StepNode
     */
    public function getStepNode()
    {
        return $this->node;
    }
}
