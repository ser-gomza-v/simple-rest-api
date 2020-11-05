<?php

declare(strict_types=1);

namespace SimpleRest\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191119203250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE goods (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders_goods (order_id INT NOT NULL, good_id INT NOT NULL, INDEX IDX_44C9168C8D9F6D38 (order_id), INDEX IDX_44C9168C1CF98C70 (good_id), PRIMARY KEY(order_id, good_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders_goods ADD CONSTRAINT FK_44C9168C8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders_goods ADD CONSTRAINT FK_44C9168C1CF98C70 FOREIGN KEY (good_id) REFERENCES goods (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders_goods DROP FOREIGN KEY FK_44C9168C1CF98C70');
        $this->addSql('ALTER TABLE orders_goods DROP FOREIGN KEY FK_44C9168C8D9F6D38');
        $this->addSql('DROP TABLE goods');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE orders_goods');
    }
}
