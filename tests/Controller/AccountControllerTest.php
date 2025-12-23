<?php

namespace App\Tests\Controller;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AccountControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $accountRepository;
    private string $path = '/account/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->accountRepository = $this->manager->getRepository(Account::class);

        foreach ($this->accountRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Account index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'account[name]' => 'Testing',
            'account[description]' => 'Testing',
            'account[currency]' => 'Testing',
            'account[starting_balance]' => 'Testing',
            'account[exclude_from_total_balance]' => 'Testing',
            'account[createdBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->accountRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Account();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCurrency('My Title');
        $fixture->setStarting_balance('My Title');
        $fixture->setExclude_from_total_balance('My Title');
        $fixture->setCreatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Account');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Account();
        $fixture->setName('Value');
        $fixture->setDescription('Value');
        $fixture->setCurrency('Value');
        $fixture->setStarting_balance('Value');
        $fixture->setExclude_from_total_balance('Value');
        $fixture->setCreatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'account[name]' => 'Something New',
            'account[description]' => 'Something New',
            'account[currency]' => 'Something New',
            'account[starting_balance]' => 'Something New',
            'account[exclude_from_total_balance]' => 'Something New',
            'account[createdBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/account/');

        $fixture = $this->accountRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getCurrency());
        self::assertSame('Something New', $fixture[0]->getStarting_balance());
        self::assertSame('Something New', $fixture[0]->getExclude_from_total_balance());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Account();
        $fixture->setName('Value');
        $fixture->setDescription('Value');
        $fixture->setCurrency('Value');
        $fixture->setStarting_balance('Value');
        $fixture->setExclude_from_total_balance('Value');
        $fixture->setCreatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/account/');
        self::assertSame(0, $this->accountRepository->count([]));
    }
}
