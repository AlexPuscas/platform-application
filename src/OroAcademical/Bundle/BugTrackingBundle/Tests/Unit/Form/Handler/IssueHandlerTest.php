<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Unit\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\ORM\EntityRepository;
use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use OroAcademical\Bundle\BugTrackingBundle\Entity\Issue;
use OroAcademical\Bundle\BugTrackingBundle\Form\Handler\IssueHandler;

class IssueHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IssueHandler
     */
    protected $handler;

    /**
     * @var FormInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $form;

    /**
     * @var Request|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * @var ObjectManager
     */
    protected $manager;

    protected function setUp()
    {
        $this->form = $this->getMock(FormInterface::class);
        $this->request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $this->manager = $this->getMockBuilder(ObjectManager::class)->disableOriginalConstructor()->getMock();;

        $this->handler = new IssueHandler($this->form, $this->request, $this->manager);
    }

    public function testPrepareFormDataNoAssignee()
    {
        /** @var Issue|\PHPUnit_Framework_MockObject_MockObject $entity */
        $entity = $this->getMock(Issue::class);
        $entity->expects($this->once())->method('getAssignee')->willReturn(new User());
        $entity->expects($this->never())->method('setAssignee');

        $this->handler->process($entity);
    }

    public function testPrepareFormDataNoWidgetContainer()
    {
        /** @var Issue|\PHPUnit_Framework_MockObject_MockObject $entity */
        $entity = $this->getMock(Issue::class);
        $entity->expects($this->once())->method('getAssignee')->willReturn(null);
        $this->request->expects($this->once())->method('get')->with('_widgetContainer')->willReturn(null);
        $entity->expects($this->never())->method('setAssignee');

        $this->handler->process($entity);
    }

    public function testPrepareFormDataNoEntityClass()
    {
        /** @var Issue|\PHPUnit_Framework_MockObject_MockObject $entity */
        $entity = $this->getMock(Issue::class);
        $entity->expects($this->once())->method('getAssignee')->willReturn(null);
        $this->request->expects($this->at(0))->method('get')->with('_widgetContainer')->willReturn('container');
        $this->request->expects($this->at(1))->method('get')->with('entityClass')->willReturn('Some_Class');
        $entity->expects($this->never())->method('setAssignee');

        $this->handler->process($entity);
    }

    public function testPrepareFormData()
    {
        /** @var Issue|\PHPUnit_Framework_MockObject_MockObject $entity */
        $entity = $this->getMock(Issue::class);
        $repository = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()->getMock();;
        $entity->expects($this->once())->method('getAssignee')->willReturn(null);
        $user = new User();
        $this->request->expects($this->at(0))->method('get')->with('_widgetContainer')->willReturn('container');
        $this
            ->request
            ->expects($this->at(1))
            ->method('get')
            ->with('entityClass')
            ->willReturn('Oro_Bundle_UserBundle_Entity_User');
        $this
            ->manager
            ->expects($this->once())
            ->method('getRepository')
            ->with('OroUserBundle:User')
            ->willReturn($repository);
        $this->request->expects($this->at(2))->method('get')->with('entityId')->willReturn(1);
        $repository->expects($this->once())->method('find')->with(1)->willReturn($user);
        $entity->expects($this->once())->method('setAssignee')->with($user);

        $this->handler->process($entity);
    }
}
