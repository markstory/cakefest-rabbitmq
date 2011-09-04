import logging
import subprocess
import os

log = logging.getLogger(__name__)

class Consumer(object):
    def __init__(self, channel):
        self.channel = channel

    def __call__(self, msg):
        log.debug('Handling message')
        self.call_shell(msg.body)
        self.channel.basic_ack(msg.delivery_tag)

    def call_shell(self, msg):
        subprocess.Popen(['Console/cake', 'log', '--quiet', msg])
        log.info('Saved pageview')


