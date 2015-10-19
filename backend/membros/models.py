from django.db import models


class Contato(models.Model):

    residencial = models.CharField(max_length=20, verbose_name='Residencial', null=True)
    celular1 = models.CharField(max_length=20, verbose_name='Celular 1', null=True)
    celular2 = models.CharField(max_length=20, verbose_name='Celular 1', null=True)
    email = models.EmailField()
    facebook = models.CharField(max_length=50, verbose_name='Facebook', null=True)


class Endereco(models.Model):

    logradouro = models.CharField(max_length=100, verbose_name='Logradouro')
    numero = models.CharField(max_length=20, verbose_name='Numero')
    bairro = models.CharField(max_length=50, verbose_name='Bairro')
    complemento = models.CharField(max_length=50, verbose_name='Complemento', null=True, blank=True)
    cep = models.CharField(max_length=10, verbose_name='CEP', null=True, blank=True)

    def __str__(self):
        return self.bairro


class Cargo(models.Model):

    cargo = models.CharField(max_length=20, verbose_name='Cargo', null=True)
    data_consagracao = models.DateField(null=True, verbose_name='Data consagração')
    igreja = models.CharField(max_length=50, verbose_name='Igreja', null=True)
    cidade = models.CharField(max_length=50, verbose_name='Cidade', null=True)

    def __str__(self):
        return self.cargo


class HistoricoEclesiastico(models.Model):

    data_conversao = models.DateField(verbose_name='Data conversão', null=True)
    data_batismo = models.DateField(verbose_name='Data batismo', null=True)
    cargo = models.ForeignKey('Cargo', related_name='cargos', null=True, on_delete=models.SET_NULL)


class Teologia(models.Model):

    curso = models.CharField(max_length=100, verbose_name='Curso')
    instituicao = models.CharField(max_length=100, verbose_name='Instituição')
    duracao = models.CharField(max_length=20, verbose_name='Duração')
    # anexos = models.FileField(null=True)

    def __str__(self):
        return self.curso


class HistoricoFamiliar(models.Model):
    ESTADO_CIVIL = (
        ('C', 'Casado(a)'),
        ('S', 'Solteiro(a)'),
        ('V', 'Viúvo(a)'),
        ('D', 'Divorciado(a)'),
    )
    estado_civil = models.CharField(max_length=1, choices=ESTADO_CIVIL,
                                    verbose_name='Estado civil')
    data_casamento = models.DateField(verbose_name='Data do casamento', null=True)
    nome_conjuje = models.CharField(max_length=100, verbose_name='Nome conjuje', null=True)
    filhos = models.BooleanField(verbose_name='Filhos?', default=False)
    nr_filhos = models.PositiveIntegerField(verbose_name='Número de filhos')


class Membro(models.Model):
    SEXO = (
        ('M', 'Masculino'),
        ('F', 'Feminino'),
    )
    matricula = models.AutoField(primary_key=True)
    nome = models.CharField(max_length=100, verbose_name='Nome')
    rg = models.CharField(max_length=15, verbose_name='RG', null=True)
    sexo = models.CharField(max_length=1, choices=SEXO, verbose_name='Sexo')
    data_nascimento = models.DateField(verbose_name='Data de nascimento')
    tipo_sanguineo = models.CharField(max_length=3, verbose_name='Tipo sanguineo', null=True)
    nome_mae = models.CharField(max_length=100, verbose_name='Nome da mãe', null=True)
    nome_pai = models.CharField(max_length=100, verbose_name='Nome do pai', null=True)
    endereco = models.ForeignKey('Endereco', related_name='endereco', null=True)
    historico_familiar = models.ForeignKey('HistoricoFamiliar', related_name='historico_familiar', null=True)
    contato = models.ForeignKey('Contato', related_name='contato', null=True)
    historico_eclesiastico = models.ForeignKey('HistoricoEclesiastico', related_name='historico_eclesiastico', null=True)
    teologia = models.ForeignKey('Teologia', related_name='teologia', null=True)

    def __str__(self):
        return self.nome
