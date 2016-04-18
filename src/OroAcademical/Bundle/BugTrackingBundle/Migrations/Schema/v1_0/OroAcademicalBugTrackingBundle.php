<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class OroAcademicalBugTrackingBundle implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createBugtrackingIssueTypesTable($schema);
        $this->createBugtrackingIssuesTable($schema);
        $this->createBugtrackingIssuesToOroTagTagTable($schema);
        $this->createBugtrackingIssuesToOroUserUserTable($schema);
        $this->createBugtrackingPrioritiesTable($schema);
        $this->createBugtrackingResolutionsTable($schema);

        /** Foreign keys generation **/
        $this->addBugtrackingIssuesForeignKeys($schema);
        $this->addBugtrackingIssuesToOroTagTagForeignKeys($schema);
        $this->addBugtrackingIssuesToOroUserUserForeignKeys($schema);
    }

    /**
     * Create bugtracking_issue_types table
     *
     * @param Schema $schema
     */
    protected function createBugtrackingIssueTypesTable(Schema $schema)
    {
        $table = $schema->createTable('bugtracking_issue_types');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('description', 'text', []);
        $table->setPrimaryKey(['id']);
    }

    /**
     * Create bugtracking_issues table
     *
     * @param Schema $schema
     */
    protected function createBugtrackingIssuesTable(Schema $schema)
    {
        $table = $schema->createTable('bugtracking_issues');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('resolution_id', 'integer', ['notnull' => false]);
        $table->addColumn('priority_id', 'integer', ['notnull' => false]);
        $table->addColumn('parent_id', 'integer', ['notnull' => false]);
        $table->addColumn('assignee_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('type_id', 'integer', ['notnull' => false]);
        $table->addColumn('reporter_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('summary', 'string', ['length' => 255]);
        $table->addColumn('code', 'string', ['length' => 255]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('status', 'integer', []);
        $table->addColumn('created', 'datetime', []);
        $table->addColumn('updated', 'datetime', []);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['type_id'], 'IDX_7484C4BBC54C8C93', []);
        $table->addIndex(['priority_id'], 'IDX_7484C4BB497B19F9', []);
        $table->addIndex(['resolution_id'], 'IDX_7484C4BB12A1C43A', []);
        $table->addIndex(['reporter_user_id'], 'IDX_7484C4BBDF3D6D95', []);
        $table->addIndex(['assignee_user_id'], 'IDX_7484C4BBBA8D7F59', []);
        $table->addIndex(['parent_id'], 'IDX_7484C4BB727ACA70', []);
    }

    /**
     * Create bugtracking_issues_to_oro_tag_tag table
     *
     * @param Schema $schema
     */
    protected function createBugtrackingIssuesToOroTagTagTable(Schema $schema)
    {
        $table = $schema->createTable('bugtracking_issues_to_oro_tag_tag');
        $table->addColumn('issue_id', 'integer', []);
        $table->addColumn('issue_tag_id', 'integer', []);
        $table->setPrimaryKey(['issue_id', 'issue_tag_id']);
        $table->addIndex(['issue_id'], 'IDX_F8372D2D5E7AA58C', []);
        $table->addIndex(['issue_tag_id'], 'IDX_F8372D2D4822E936', []);
    }

    /**
     * Create bugtracking_issues_to_oro_user_user table
     *
     * @param Schema $schema
     */
    protected function createBugtrackingIssuesToOroUserUserTable(Schema $schema)
    {
        $table = $schema->createTable('bugtracking_issues_to_oro_user_user');
        $table->addColumn('issue_id', 'integer', []);
        $table->addColumn('issue_collaborator_id', 'integer', []);
        $table->setPrimaryKey(['issue_id', 'issue_collaborator_id']);
        $table->addIndex(['issue_id'], 'IDX_F5A093055E7AA58C', []);
        $table->addIndex(['issue_collaborator_id'], 'IDX_F5A093052846783F', []);
    }

    /**
     * Create bugtracking_priorities table
     *
     * @param Schema $schema
     */
    protected function createBugtrackingPrioritiesTable(Schema $schema)
    {
        $table = $schema->createTable('bugtracking_priorities');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('description', 'text', []);
        $table->addColumn('priority', 'integer', []);
        $table->setPrimaryKey(['id']);
    }

    /**
     * Create bugtracking_resolutions table
     *
     * @param Schema $schema
     */
    protected function createBugtrackingResolutionsTable(Schema $schema)
    {
        $table = $schema->createTable('bugtracking_resolutions');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);
    }

    /**
     * Add bugtracking_issues foreign keys.
     *
     * @param Schema $schema
     */
    protected function addBugtrackingIssuesForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('bugtracking_issues');
        $table->addForeignKeyConstraint(
            $schema->getTable('bugtracking_resolutions'),
            ['resolution_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('bugtracking_priorities'),
            ['priority_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('bugtracking_issues'),
            ['parent_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['assignee_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('bugtracking_issue_types'),
            ['type_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['reporter_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * Add bugtracking_issues_to_oro_tag_tag foreign keys.
     *
     * @param Schema $schema
     */
    protected function addBugtrackingIssuesToOroTagTagForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('bugtracking_issues_to_oro_tag_tag');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_tag_tag'),
            ['issue_tag_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('bugtracking_issues'),
            ['issue_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    /**
     * Add bugtracking_issues_to_oro_user_user foreign keys.
     *
     * @param Schema $schema
     */
    protected function addBugtrackingIssuesToOroUserUserForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('bugtracking_issues_to_oro_user_user');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['issue_collaborator_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('bugtracking_issues'),
            ['issue_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }
}
