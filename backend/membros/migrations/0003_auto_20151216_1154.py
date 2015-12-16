# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import models, migrations


class Migration(migrations.Migration):

    dependencies = [
        ('membros', '0002_auto_20151102_1806'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='historicoeclesiastico',
            name='cargo',
        ),
        migrations.AddField(
            model_name='historicoeclesiastico',
            name='cargos',
            field=models.ManyToManyField(related_name='cargos', to='membros.Cargo', blank=True),
            preserve_default=True,
        ),
        migrations.AlterField(
            model_name='contato',
            name='email',
            field=models.EmailField(max_length=75, null=True, blank=True),
        ),
    ]
