<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929042301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert Sale page into dtb_page';
    }

    public function up(Schema $schema): void
    {
        $count = $this->connection->fetchOne("SELECT COUNT(*) FROM dtb_page WHERE url = 'sale'");
        if ($count > 0) {
            return;
        }

        $pageId = $this->connection->fetchOne('SELECT MAX(id) FROM dtb_page');
        $sortNo = $this->connection->fetchOne('SELECT MAX(sort_no) FROM dtb_page_layout');

        $pageId++;
        $this->addSql("INSERT INTO dtb_page (
            id, master_page_id, page_name, url, file_name, edit_type, create_date, update_date, meta_robots, discriminator_type
        ) VALUES (
            $pageId, 2, 'セールページ', 'sale', 'Sale/index', 3, NOW(), NOW(), 'index,follow', 'page'
        )");

        $sortNo++;
        $this->addSql("INSERT INTO dtb_page_layout (page_id, layout_id, sort_no, discriminator_type) VALUES ($pageId, 2, $sortNo, 'pagelayout')");

        if ($this->platform->getName() === 'postgresql') {
           $this->addSql("SELECT setval('dtb_page_id_seq', $pageId)");
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM dtb_page_layout WHERE page_id IN (SELECT id FROM dtb_page WHERE url = 'sale')");
        $this->addSql("DELETE FROM dtb_page WHERE url = 'sale'");
    }
}
