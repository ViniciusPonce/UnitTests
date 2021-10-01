<?php

namespace UnitTest\PublicSale\Tests\Service;

use UnitTest\PublicSale\Model\Lance;
use UnitTest\PublicSale\Model\Leilao;
use UnitTest\PublicSale\Model\Usuario;
use UnitTest\PublicSale\Service\Avaliador;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;

class AvaliadorTest extends TestCase
{
    public function testEvaluatorMustFindTheHighestBidAmountInAscendingOrder()
    {
        // Arrange - Given
        $leilao = new Leilao('Carro 0 Km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        $leiloeiro = new Avaliador();

        // Act - When
        $leiloeiro->avalia($leilao);

        $maiorValor = $leiloeiro->getMaiorValor();

        // Assert - Then
        $this->assertEquals(2500, $maiorValor);
    }
    public function testEvaluatorMustFindTheHighestBidAmountInDecreasingOrder()
    {
        // Arrange - Given
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));

        $leiloeiro = new Avaliador();

        // Act - When
        $leiloeiro->avalia($leilao);

        $maiorValor = $leiloeiro->getMaiorValor();

        // Assert - Then
        $this->assertEquals(2500, $maiorValor);
    }

    public function testEvaluatorMustFindTheLowestBidAmountInDecreasingOrder()
    {
        // Arrange - Given
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));

        $leiloeiro = new Avaliador();

        // Act - When
        $leiloeiro->avalia($leilao);

        $menorValor = $leiloeiro->getMenorValor();

        // Assert - Then
        $this->assertEquals(2000, $menorValor);
    }

    public function testEvaluatorMustFindThelowestBidAmountInAscendingOrder()
    {
        // Arrange - Given
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        $leiloeiro = new Avaliador();

        // Act - When
        $leiloeiro->avalia($leilao);

        $menorValor = $leiloeiro->getMenorValor();

        // Assert - Then
        $this->assertEquals(2000, $menorValor);
    }

    public function testAvaliadorDeveBuscar3MaioresValores() 
    {
        $leilao = new Leilao('Fiat 147 0 KM');

        $usuarioLance1 = new Usuario('Vinicius');
        $usuarioLance2 = new Usuario('Carlos');
        $usuarioLance3 = new Usuario('Ornella');
        $usuarioLance4 = new Usuario('Jorge');

        $leilao->recebeLance(new Lance($usuarioLance1, 1500));
        $leilao->recebeLance(new Lance($usuarioLance2, 1000));
        $leilao->recebeLance(new Lance($usuarioLance3, 2000));
        $leilao->recebeLance(new Lance($usuarioLance4, 1700));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $maioresLances = $leiloeiro->getMaioresLances();
        
        static::assertCount(3, $maioresLances);
        static::assertEquals(2000, $maioresLances[0]->getValor());
        static::assertEquals(1700, $maioresLances[1]->getValor());
        static::assertEquals(1500, $maioresLances[2]->getValor());

    }

}