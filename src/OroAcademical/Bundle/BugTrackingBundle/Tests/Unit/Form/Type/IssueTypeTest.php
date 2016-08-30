<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Unit\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\FormIntegrationTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use OroAcademical\Bundle\BugTrackingBundle\Entity\Issue;
use OroAcademical\Bundle\BugTrackingBundle\Form\Type\IssueType;

class IssueTypeTest extends FormIntegrationTestCase
{
    /**
     * @var IssueType
     */
    protected $issueType;

    /**
     * @return array
     */
    public function getExtensions()
    {
        $validator = $this->getMock(ValidatorInterface::class);
        $entityType = $this->getMockBuilder(EntityType::class)->disableOriginalConstructor()->getMock();

        $validator
            ->expects($this->any())
            ->method('getMetadataFor')
            ->willReturn($this->getMockBuilder(ClassMetadata::class)->disableOriginalConstructor()->getMock());
        $validator->expects($this->any())->method('validate')->willReturn([]);
        $entityType->expects($this->any())->method('getName')->willReturn('entity');
        $entityType
            ->expects($this->any())
            ->method('setDefaultOptions')
            ->will(
                $this->returnCallback(
                    function (OptionsResolver $resolver) {
                        $resolver->setDefaults(
                            [
                                'choice_label' => null,
                                'class' => null,
                                'choice_translation_domain' => null,
                                'label' => null,
                                'property' => null,
                                'required' => null,
                                'query_builder' => null,
                            ]
                        );
                    }
                )
            );

        return [
            new ValidatorExtension($validator),
            new PreloadedExtension([$entityType->getName() => $entityType], []),
        ];
    }

    public function testBuildForm()
    {
        $this->issueType = $this->factory->create(new IssueType(), new Issue());
        $fields = [
            'summary' => [
                'type' => 'text',
                'required' => true,
                'label' => 'bugtracking.issue.summary.label',
            ],
            'code' => [
                'type' => 'text',
                'required' => true,
                'label' => 'bugtracking.issue.code.label',
            ],
            'description' => [
                'type' => 'text',
                'required' => false,
                'label' => 'bugtracking.issue.description.label',
            ],
            'type' => [
                'type' => 'entity',
                'required' => true,
                'label' => 'bugtracking.issue.taskType.label',
                'class'  => 'OroAcademicalBugTrackingBundle:IssueType',
            ],
            'priority' => [
                'type' => 'entity',
                'required' => true,
                'label' => 'bugtracking.issue.taskPriority.label',
                'class' => 'OroAcademicalBugTrackingBundle:Priority',
            ],
            'resolution' => [
                'type' => 'entity',
                'required' => true,
                'label' => 'bugtracking.issue.taskResolution.label',
                'class' => 'OroAcademicalBugTrackingBundle:Resolution',
            ],
            'status' => [
                'type' => 'choice',
                'choices' => Issue::getStatusses(),
                'required' => false,
                'label' => 'bugtracking.issue.status.label',
            ],
            'reporter' => [
                'type' => 'entity',
                'required' => true,
                'label' => 'bugtracking.issue.taskReporter.label',
                'class' => 'OroUserBundle:User'
            ],
            'assignee' => [
                'type' => 'entity',
                'required' => true,
                'label' => 'bugtracking.issue.taskAssignee.label',
                'class' => 'OroUserBundle:User'
            ],
        ];
        foreach ($fields as $field => $config) {
            $this->assertTrue($this->issueType->has($field));
            $actualConfig = $this->issueType->get($field);
            $this->assertEquals($config['type'], $actualConfig->getConfig()->getType()->getName());
            unset($config['type']);
            foreach ($config as $configName => $configValue) {
                $fieldConfig = $actualConfig->getConfig()->getOption($configName);
                $this->assertEquals($configValue, $actualConfig->getConfig()->getOption($configName));
            }
        }
    }

    public function testProcess()
    {
        $issue = new Issue();
        $issue->setCode('code')->setDescription('description')->setSummary('summary');
        $this->issueType = $this->factory->create(new IssueType(), $issue);

        /** @var Issue $data */
        $data = $this->issueType->getData();
        $this->assertEquals($issue->getCode(), $data->getCode());
        $this->assertEquals($issue->getDescription(), $data->getDescription());
        $this->assertEquals($issue->getSummary(), $data->getSummary());


        $requestData = [
            'code' => 'newCode',
            'description' => 'newDescription',
            'summary' => 'newSummary',
        ];
        $this->issueType->submit($requestData);
        $data = $this->issueType->getData();
        $this->assertEquals($requestData['code'], $data->getCode());
        $this->assertEquals($requestData['description'], $data->getDescription());
        $this->assertEquals($requestData['summary'], $data->getSummary());
    }
}
