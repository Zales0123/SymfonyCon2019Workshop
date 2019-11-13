<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191112143110 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_subscription ADD product_id INT DEFAULT NULL, DROP product_name');
        $this->addSql('ALTER TABLE app_subscription ADD CONSTRAINT FK_61487E524584665A FOREIGN KEY (product_id) REFERENCES sylius_product_variant (id)');
        $this->addSql('CREATE INDEX IDX_61487E524584665A ON app_subscription (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_subscription DROP FOREIGN KEY FK_61487E524584665A');
        $this->addSql('DROP INDEX IDX_61487E524584665A ON app_subscription');
        $this->addSql('ALTER TABLE app_subscription ADD product_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP product_id');
    }
}
