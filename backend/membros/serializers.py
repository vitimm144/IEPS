from rest_framework import serializers
from membros.models import Membro





class MembroSerializer(serializers.ModelSerializer):
    # historico_familiar = serializers.PrimaryKeyRelatedField(many=False)
    # teologia = serializers.PrimaryKeyRelatedField(many=False)
    # historico_eclesiastico = serializers.PrimaryKeyRelatedField(many=False)
    # endereco = serializers.PrimaryKeyRelatedField(many=False)
    # contato = serializers.PrimaryKeyRelatedField(many=False)

    class Meta:
        model = Membro
        depth = 1