import os
from setuptools import setup

setup(
    name = "consume",
    version = "0.0.1",
    author = "Mark Story",
    author_email = "mark@mark-story.com",
    description = ("an example event consumer"),
    license = "MIT",
    keywords = "example amqp tutorial",
    url = "",
    packages=['consume'],
    install_requires=[
        "sparkplug==1.2.1"
        ],
    entry_points = {
        'sparkplug.consumers': [
            'echo = consume:Consumer'
        ]
    }
)

