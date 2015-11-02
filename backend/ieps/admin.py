from django.contrib.admin import AdminSite


class IepsSite(AdminSite):
    site_header = 'IEPS'
    site_title = 'IEPS'


admin_site = IepsSite(name='admin')
