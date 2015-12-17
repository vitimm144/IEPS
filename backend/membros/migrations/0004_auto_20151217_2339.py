# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import models, migrations


class Migration(migrations.Migration):

    dependencies = [
        ('membros', '0003_auto_20151216_1154'),
    ]

    operations = [
        migrations.AlterField(
            model_name='cargo',
            name='cidade',
            field=models.CharField(blank=True, verbose_name='Cidade', max_length=50, null=True),
        ),
        migrations.AlterField(
            model_name='cargo',
            name='data_consagracao',
            field=models.DateField(blank=True, verbose_name='Data consagração', null=True),
        ),
        migrations.AlterField(
            model_name='cargo',
            name='igreja',
            field=models.CharField(blank=True, verbose_name='Igreja', max_length=50, null=True),
        ),
        migrations.AlterField(
            model_name='historicofamiliar',
            name='data_casamento',
            field=models.DateField(blank=True, verbose_name='Data do casamento', null=True),
        ),
        migrations.AlterField(
            model_name='historicofamiliar',
            name='nome_conjuje',
            field=models.CharField(blank=True, verbose_name='Nome conjuje', max_length=100, null=True),
        ),
        migrations.AlterField(
            model_name='historicofamiliar',
            name='nr_filhos',
            field=models.PositiveIntegerField(blank=True, verbose_name='Número de filhos', null=True),
        ),
    ]
