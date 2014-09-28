from rest_framework import serializers
from .models import Membro


class MembroSerializer(serializers.ModelSerializer):

    class Meta:
        model = Membro
        depth = 1