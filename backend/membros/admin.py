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
    list_display = ('data_conversao', 'data_batismo', 'membro', 'cargo_names')
    list_filter = ('data_conversao', 'data_batismo', 'membro')
    search_fields = ('data_conversao', 'data_batismo', 'membro__nome')


class TeologiaAdmin(admin.ModelAdmin):
    list_display = ('curso', 'instituição', 'duracao', 'membro')
    list_filter = ('curso', 'instituição', 'duracao', 'membro')
    seach_fields = ('curso', 'instituição', 'duracao', 'membro__nome')


class EnderecoAdmin(admin.ModelAdmin):
    list_display = ('logradouro', 'numero', 'bairro', 'cep', 'membro')
    list_filter = ('logradouro', 'numero', 'bairro', 'cep', 'membro')
    search_fields = ('logradouro', 'bairro', 'cep', 'membro__nome')


class ContatoAdmin(admin.ModelAdmin):
    list_display = ('residencial', 'celular1', 'celular2', 'membro')
    list_filter = ('residencial', 'celular1', 'celular2', 'membro')
    search_fields = ('residencial', 'celular1', 'celular2', 'membro__nome')


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
    search_fields = (
        'matricula',
        'nome',
        'data_nascimento',
        'endereco__logradouro',
        'endereco__numero'
    )


class CargoAdmin(admin.ModelAdmin):
    list_display = ('cargo', 'data_consagracao', 'igreja', 'cidade',)
    list_filter = ('cargo', 'igreja', 'cidade',)
    search_fields = ('cargo', 'data_consagracao', 'igreja', 'cidade')


class HistoricoFamiliarAdmin(admin.ModelAdmin):
    list_display = ('estado_civil', 'data_casamento', 'nome_conjuje', 'membro')
    list_filter = ('estado_civil', 'data_casamento', 'nome_conjuje', 'membro')
    search_fields = ('estado_civil', 'data_casamento', 'nome_conjuje', 'membro__nome')


# Register your models here.
admin_site.register(Membro, MembroAdmin)
admin_site.register(Cargo, CargoAdmin)
admin_site.register(HistoricoEclesiastico, HistoricoEclesiasticoAdmin)
admin_site.register(Endereco, EnderecoAdmin)
admin_site.register(Contato, ContatoAdmin)
admin_site.register(HistoricoFamiliar, HistoricoFamiliarAdmin)
