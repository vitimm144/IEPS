from django.conf.urls import patterns, include, url
from ieps.admin import admin_site
from django.contrib import admin


admin.autodiscover()

urlpatterns = patterns(
    '',
    url(r'^admin/', include(admin_site.urls)),
)
