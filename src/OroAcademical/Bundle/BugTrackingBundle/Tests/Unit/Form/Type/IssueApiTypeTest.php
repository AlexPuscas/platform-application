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
use OroAcademical\Bundle\BugTrackingBundle\Form\Type\IssueApiType;
use OroAcademical\Bundle\BugTrackingBundle\Form\Type\IssueType;

class IssueApiTypeTest extends FormIntegrationTestCase
{
    /**
     * @var IssueApiType
     */
    protected $issueType;

    public function getExtensions()
    {
        $validator = $this->getMock(ValidatorInterface::class);
        $entityType = $this->getMockBuilder(EntityType::class)->disableOriginalConstructor()->getMock();
        $issueType = new IssueType();

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
            new PreloadedExtension([$entityType->getName() => $entityType, $issueType->getName() => $issueType ], []),
        ];
    }

    public function testProcess()
    {
        $issue = new Issue();
        $issue->setCode('code')->setDescription('description')->setSummary('summary');
        $this->issueType = $this->factory->create(new IssueApiType(), $issue);

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
