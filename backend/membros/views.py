from django.shortcuts import render
from rest_framework.viewsets import ModelViewSet
from .serializers import MembroSerializer
from membros.models import Membro
from rest_framework.authentication import SessionAuthentication, BasicAuthentication
from rest_framework.permissions import IsAuthenticated


class MembroViewSet(ModelViewSet):

    queryset = Membro.objects.all()
    serializer_class = MembroSerializer
    authentication_classes = (SessionAuthentication, BasicAuthentication)
    permission_classes = (IsAuthenticated,)



