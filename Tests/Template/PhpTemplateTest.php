<?php

/*
 * This file is part of the Ivory CKEditor package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\CKEditorBundle\Tests\Template;

use Ivory\CKEditorBundle\Templating\CKEditorHelper;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

/**
 * PHP template test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class PhpTemplateTest extends AbstractTemplateTest
{
    /** @var \Symfony\Component\Templating\PhpEngine */
    private $phpEngine;

    /** @var \Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper|\PHPUnit_Framework_MockObject_MockObject */
    private $formHelperMock;

    /** @var \Symfony\Component\Templating\Helper\SlotsHelper|\PHPUnit_Framework_MockObject_MockObject */
    private $slotsHelperMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->formHelperMock = $this->getMockBuilder('Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper')
            ->disableOriginalConstructor()
            ->getMock();

        $this->slotsHelperMock = $this->getMockBuilder('Symfony\Component\Templating\Helper\SlotsHelper')
            ->disableOriginalConstructor()
            ->getMock();

        $this->phpEngine = new PhpEngine(
            new TemplateNameParser(),
            new FilesystemLoader(array(__DIR__.'/../../Resources/views/Form/%name%')),
            array(
                'form'  => $this->formHelperMock,
                'slots' => $this->slotsHelperMock,
                new CKEditorHelper($this->renderer),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        unset($this->formHelperMock);
        unset($this->phpEngine);
    }

    /**
     * {@inheritdoc}
     */
    protected function renderTemplate(array $context = array())
    {
        return $this->phpEngine->render('ckeditor_widget.html.php', $context);
    }
}
