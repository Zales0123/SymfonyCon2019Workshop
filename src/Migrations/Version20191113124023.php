<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113124023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_order ADD subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_order ADD CONSTRAINT FK_6196A1F99A1887DC FOREIGN KEY (subscription_id) REFERENCES app_subscription (id)');
        $this->addSql('CREATE INDEX IDX_6196A1F99A1887DC ON sylius_order (subscription_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_order DROP FOREIGN KEY FK_6196A1F99A1887DC');
        $this->addSql('DROP INDEX IDX_6196A1F99A1887DC ON sylius_order');
        $this->addSql('ALTER TABLE sylius_order DROP subscription_id');
    }
}
