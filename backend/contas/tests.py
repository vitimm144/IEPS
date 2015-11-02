from django.test import LiveServerTestCase
# from django.contrib.auth.models import User
from rest_framework import status
from rest_framework.reverse import reverse


# class ContasTestCase(LiveServerTestCase):
#     fixtures = ['auth_user',]
#
#     def setUp(self):
#         # self.user = User.objects.get(username='admin')
#         # self.client.force_authenticate(user=self.user)
#         self.client.login(username='admin', password='admin')
#
#     def test_list_user(self):
#         # import ipdb; ipdb.set_trace()
#         response = self.client.get(reverse('admin:auth_user'))
#         self.assertEqual(response.status_code, status.HTTP_200_OK)
#