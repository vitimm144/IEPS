from rest_framework.test import APITestCase
from django.core.urlresolvers import reverse
from rest_framework import status
from django.contrib.auth.models import User


class MembroViewTestCase(APITestCase):

    fixtures = ['auth', 'user']

    def setUp(self):
        self.user = User.objects.get(username='admin')
        self.client.force_authenticate(user=self.user)

    def test_create_membro(self):
        membro =  {
            "nome": "Nome",
            "rg": "1234567",
            "sexo": "M",
            "data_nascimento": "2001-01-01",
            "tipo_sanguineo": "A+",
            "nome_mae": "Mae",
            "nome_pai": "Pai",
            "endereco": {
                "logradouro": "Rua das ruas",
                "numero": "1234",
                "bairro": "bairro",
                "complemento": "complemento",
                "cep": "12354"
            },
            "historico_familiar": {
                "estado_civil": "C",
                "data_casamento": "2007-10-13",
                "nome_conjuje": "Conjuje",
                "filhos": False,
                "nr_filhos": 0
            },
            "contato": {
                "residencial": "123123",
                "celular1": "111",
                "celular2": "222",
                "email": "bla@bla.com",
                "facebook": "face@face.com"
            },
            "historico_eclesiastico": {
                "data_conversao": "2003-02-01",
                "data_batismo": "2003-03-16",
                "cargo": {
                    "cargo": "Cargo",
                    "data_consagracao": "1999-05-05",
                    "igreja": "Igreja",
                    "cidade": "Cidade"
                }
            },
            "teologia": {
                "curso": "Curso",
                "instituicao": "Instituicao",
                "duracao": "2 anos"
            }

        }
        response = self.client.post(reverse('membro-list'), data=membro)
        import ipdb; ipdb.set_trace()
        self.assertEqual(response.status_code, status.HTTP_201_CREATED)


    def test_edit_membro(self):
        pass

    def test_list_membros(self):
        pass

    def test_delete_membro(self):
        pass