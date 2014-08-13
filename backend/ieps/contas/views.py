from django.shortcuts import render
from django.contrib.auth.models import User
from rest_framework import viewsets
from .serializers import UserSerializer


# Create your views here.
class UserViewSet(viewsets.ModelViewSet):

    model = User
    serializer_class = UserSerializer