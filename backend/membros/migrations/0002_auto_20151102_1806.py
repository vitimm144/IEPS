# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('membros', '0001_initial'),
    ]

    operations = [
        migrations.AlterField(
            model_name='contato',
            name='celular1',
            field=models.CharField(blank=True, max_length=20, verbose_name='Celular 1', null=True),
        ),
        migrations.AlterField(
            model_name='contato',
            name='celular2',
            field=models.CharField(blank=True, max_length=20, verbose_name='Celular 1', null=True),
        ),
        migrations.AlterField(
            model_name='contato',
            name='email',
            field=models.EmailField(blank=True, max_length=254, null=True),
        ),
        migrations.AlterField(
            model_name='contato',
            name='facebook',
            field=models.CharField(blank=True, max_length=50, verbose_name='Facebook', null=True),
        ),
        migrations.AlterField(
            model_name='contato',
            name='residencial',
            field=models.CharField(blank=True, max_length=20, verbose_name='Residencial', null=True),
        ),
    ]
