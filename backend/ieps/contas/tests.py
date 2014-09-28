from django.test import TestCase
from django.contrib.auth.models import User
from rest_framework import status
from rest_framework.reverse import reverse


class ContasTestCase(TestCase):

    def setUp(self):
        self.user = User.objects.first()

    def test_list_user(self):
        response = self.client.get(reverse('user-list'))
        self.assertEqual(response.status_code, status.HTTP_200_OK)