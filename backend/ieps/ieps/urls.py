from django.conf.urls import patterns, include, url
from rest_framework.routers import DefaultRouter
from django.contrib import admin
from contas.views import UserViewSet

router = DefaultRouter()
router.register(r'contas', UserViewSet)


admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    # url(r'^$', 'ieps.views.home', name='home'),
    # url(r'^blog/', include('blog.urls')),

    url(r'^admin/', include(admin.site.urls)),
    url('^api/', include(router.urls)),
)
