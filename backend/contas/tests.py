from rest_framework.test import APITestCase
from django.contrib.auth.models import User
from rest_framework import status
from rest_framework.reverse import reverse


class ContasTestCase(APITestCase):
    fixtures = ['auth',]

    def setUp(self):
        self.user = User.objects.get(username='admin')
        self.client.force_authenticate(user=self.user)
        # self.client.login(username='admin', password='admin')

    def test_list_user(self):
        # import ipdb; ipdb.set_trace()
        response = self.client.get(reverse('user-list'))
        self.assertEqual(response.status_code, status.HTTP_200_OK)
