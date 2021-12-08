<?php

namespace Training\Seller\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Training\Seller\Model\Seller;
use Training\Seller\Model\SellerRepository;

class GetCommand extends Command
{
    private SellerRepository $sellerRepository;

    public function __construct(SellerRepository $sellerRepository, string $name = null)
    {
        parent::__construct($name);
        $this->sellerRepository = $sellerRepository;
    }

    public function configure(): void
    {
        parent::configure();
        $this
            ->setName('training:seller:get')
            ->setDescription('Get a seller by id')
            ->addArgument('sellerId', InputArgument::REQUIRED, 'Enter the seller id')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $sellerId = $input->getArgument('sellerId');
        /** @var Seller $seller */
        $seller = $this->sellerRepository->getById($sellerId);

        if ($seller) {
            $output->writeln('**** Find seller is: ****' .PHP_EOL);
            $output->writeln('Seller name is: '.$seller->getName() .PHP_EOL);
            $output->writeln('****');
            return 0;
        }

        return 1;
    }

}
