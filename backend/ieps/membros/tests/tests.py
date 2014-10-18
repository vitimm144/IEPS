from rest_framework.test import APITestCase
from membros.models import Membro, HistoricoFamiliar, HistoricoEclesiastico, Endereco
from membros.models import Teologia, Contato, Cargo


class ContatoModelTestCase(APITestCase):

    def Test_create_contato(self):
        contato = Contato(
            residencial='123123',
            celular1='111',
            celular2='222',
            email='bla@bla.com',
            facebook='face@face.com'
        )
        contato.save()
        self.assertEqual(contato.pk, 1)


class EnderecoModelTestCase(APITestCase):

    def test_create_endereco(self):
        endereco = Endereco(
            logradouro='Rua das ruas',
            numero='1234',
            bairro='bairro',
            complemento='complemento',
            cep='12354'
        )
        endereco.save()
        self.assertEqual(endereco.pk, 1)


class CargoModelTestCase(APITestCase):

    def test_create_cargo(self):
        cargo = Cargo(
            cargo='Cargo',
            data_consagracao='1999-05-05',
            igreja='Igreja',
            cidade='Cidade'
        )
        cargo.save()
        self.assertEqual(cargo.pk, 1)


class HistoricoEclesiasticoModelTestCase(APITestCase):

    def test_create_historicoEclesiastico(self):
        historico_eclesiastico = HistoricoEclesiastico(
            data_conversao='2003-02-01',
            data_batismo='2003-03-16',
            cargo_id=1
        )
        historico_eclesiastico.save()
        self.assertEqual(historico_eclesiastico.pk, 1)


class TeologiaModelTestCase(APITestCase):

    def test_create_teologia(self):
        teologia = Teologia(
            curso='Curso',
            instituicao='Instituicao',
            duracao='2 anos'
        )
        teologia.save()
        self.assertEqual(teologia.pk, 1)


class HistoricoFamiliarModelTestCase(APITestCase):

    def test_create_historico_familiar(self):
        historico_familiar= HistoricoFamiliar(
            estado_civil='C',
            data_casamento='2007-10-13',
            nome_conjuje='Conjuje',
            filhos=False,
            nr_filhos=0
        )
        historico_familiar.save()
        self.assertEqual(historico_familiar.pk, 1)


class MembroModelTestCase(APITestCase):

    def test_create_membro(self):
        membro = Membro(
            matricula=1,
            nome='Nome',
            rg='1234567',
            sexo='M',
            data_nascimento='2001-01-01',
            tipo_sanguineo='A+',
            nome_mae='Mae',
            nome_pai='Pai',
            endereco_id=1,
            historico_familiar_id=1,
            contato_id=1,
            historico_eclesiastico_id=1,
            teologia_id=1
        )
        membro.save()
        self.assertEqual(membro.pk, 1)
