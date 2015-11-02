# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='Cargo',
            fields=[
                ('id', models.AutoField(auto_created=True, verbose_name='ID', primary_key=True, serialize=False)),
                ('cargo', models.CharField(verbose_name='Cargo', max_length=20, null=True)),
                ('data_consagracao', models.DateField(verbose_name='Data consagração', null=True)),
                ('igreja', models.CharField(verbose_name='Igreja', max_length=50, null=True)),
                ('cidade', models.CharField(verbose_name='Cidade', max_length=50, null=True)),
            ],
        ),
        migrations.CreateModel(
            name='Contato',
            fields=[
                ('id', models.AutoField(auto_created=True, verbose_name='ID', primary_key=True, serialize=False)),
                ('residencial', models.CharField(verbose_name='Residencial', max_length=20, null=True)),
                ('celular1', models.CharField(verbose_name='Celular 1', max_length=20, null=True)),
                ('celular2', models.CharField(verbose_name='Celular 1', max_length=20, null=True)),
                ('email', models.EmailField(max_length=254)),
                ('facebook', models.CharField(verbose_name='Facebook', max_length=50, null=True)),
            ],
        ),
        migrations.CreateModel(
            name='Endereco',
            fields=[
                ('id', models.AutoField(auto_created=True, verbose_name='ID', primary_key=True, serialize=False)),
                ('logradouro', models.CharField(verbose_name='Logradouro', max_length=100)),
                ('numero', models.CharField(verbose_name='Numero', max_length=20)),
                ('bairro', models.CharField(verbose_name='Bairro', max_length=50)),
                ('complemento', models.CharField(verbose_name='Complemento', max_length=50, null=True, blank=True)),
                ('cep', models.CharField(verbose_name='CEP', max_length=10, null=True, blank=True)),
            ],
        ),
        migrations.CreateModel(
            name='HistoricoEclesiastico',
            fields=[
                ('id', models.AutoField(auto_created=True, verbose_name='ID', primary_key=True, serialize=False)),
                ('data_conversao', models.DateField(verbose_name='Data conversão', null=True)),
                ('data_batismo', models.DateField(verbose_name='Data batismo', null=True)),
                ('cargo', models.ForeignKey(to='membros.Cargo', on_delete=django.db.models.deletion.SET_NULL, null=True, related_name='cargos')),
            ],
        ),
        migrations.CreateModel(
            name='HistoricoFamiliar',
            fields=[
                ('id', models.AutoField(auto_created=True, verbose_name='ID', primary_key=True, serialize=False)),
                ('estado_civil', models.CharField(choices=[('C', 'Casado(a)'), ('S', 'Solteiro(a)'), ('V', 'Viúvo(a)'), ('D', 'Divorciado(a)')], verbose_name='Estado civil', max_length=1)),
                ('data_casamento', models.DateField(verbose_name='Data do casamento', null=True)),
                ('nome_conjuje', models.CharField(verbose_name='Nome conjuje', max_length=100, null=True)),
                ('filhos', models.BooleanField(verbose_name='Filhos?', default=False)),
                ('nr_filhos', models.PositiveIntegerField(verbose_name='Número de filhos')),
            ],
        ),
        migrations.CreateModel(
            name='Membro',
            fields=[
                ('matricula', models.AutoField(primary_key=True, serialize=False)),
                ('nome', models.CharField(verbose_name='Nome', max_length=100)),
                ('rg', models.CharField(verbose_name='RG', max_length=15, null=True)),
                ('sexo', models.CharField(choices=[('M', 'Masculino'), ('F', 'Feminino')], verbose_name='Sexo', max_length=1)),
                ('data_nascimento', models.DateField(verbose_name='Data de nascimento')),
                ('tipo_sanguineo', models.CharField(verbose_name='Tipo sanguineo', max_length=3, null=True)),
                ('nome_mae', models.CharField(verbose_name='Nome da mãe', max_length=100, null=True)),
                ('nome_pai', models.CharField(verbose_name='Nome do pai', max_length=100, null=True)),
            ],
        ),
        migrations.CreateModel(
            name='Teologia',
            fields=[
                ('id', models.AutoField(auto_created=True, verbose_name='ID', primary_key=True, serialize=False)),
                ('curso', models.CharField(verbose_name='Curso', max_length=100)),
                ('instituicao', models.CharField(verbose_name='Instituição', max_length=100)),
                ('duracao', models.CharField(verbose_name='Duração', max_length=20)),
                ('membro', models.OneToOneField(to='membros.Membro', verbose_name='Membro')),
            ],
        ),
        migrations.AddField(
            model_name='historicofamiliar',
            name='membro',
            field=models.OneToOneField(to='membros.Membro', verbose_name='Membro'),
        ),
        migrations.AddField(
            model_name='historicoeclesiastico',
            name='membro',
            field=models.OneToOneField(to='membros.Membro', verbose_name='Membro'),
        ),
        migrations.AddField(
            model_name='endereco',
            name='membro',
            field=models.OneToOneField(to='membros.Membro', verbose_name='Membro'),
        ),
        migrations.AddField(
            model_name='contato',
            name='membro',
            field=models.OneToOneField(to='membros.Membro', verbose_name='Membro'),
        ),
    ]
