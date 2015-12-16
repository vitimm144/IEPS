from django.contrib import admin
from membros.models import Cargo, HistoricoEclesiastico, Contato
from membros.models import Membro, Endereco
from membros.models import HistoricoFamiliar
from membros.models import Teologia
from ieps.admin import admin_site


class ContatoInline(admin.StackedInline):
    model = Contato
    verbose_name = 'Contato'
    verbose_name_plural = 'Contatos'
    extra = 1


class EnderecoInline(admin.StackedInline):
    model = Endereco
    verbose_name = 'Endereço'
    verbose_name_plural = 'Endereços'
    fk_name = 'membro'


class HistoricofamiliarInline(admin.StackedInline):
    model = HistoricoFamiliar
    verbose_name = 'Histórico familiar'
    verbose_name_plural = 'Históricos familiares'


class TeologiaInline(admin.StackedInline):
    model = Teologia
    verbose_name = 'Teologia'


class HistoricoEclesiasticoInline(admin.StackedInline):
    model = HistoricoEclesiastico
    verbose_name = 'Histórico eclesiático'
    verbose_name_plural = 'Históricos eclesiásticos'


class HistoricoEclesiasticoAdmin(admin.ModelAdmin):
    pass


class MembroAdmin(admin.ModelAdmin):
    inlines = (
        EnderecoInline,
        ContatoInline,
        HistoricofamiliarInline,
        TeologiaInline,
        HistoricoEclesiasticoInline
    )
    list_display = ('matricula', 'nome', 'data_nascimento', 'endereco', 'contato')
    list_filter = ('matricula', 'nome', 'sexo', 'data_nascimento',)


class CargoAdmin(admin.ModelAdmin):
    list_display = ('cargo', 'data_consagracao', 'igreja', 'cidade',)
    list_filter = ('cargo', 'igreja', 'cidade',)


# Register your models here.
admin_site.register(Membro, MembroAdmin)
admin_site.register(Cargo, CargoAdmin)
admin_site.register(HistoricoEclesiastico, HistoricoEclesiasticoAdmin)
