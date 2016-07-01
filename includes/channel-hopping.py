#!/usr/bin/env python
'''
    Copyright (C) 2016 xtr4nge [_AT_] gmail.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
'''

import datetime
a = datetime.datetime.now()

import logging
logging.getLogger("scapy.runtime").setLevel(logging.ERROR)
from scapy import *
from scapy.all import *

import time
import sys, getopt
import json
from multiprocessing import Process
import signal
import threading

# HELP MENU
def usage():
    print "\nchannel-hopping 1.0 by xtr4nge"
    
    print "Usage: channel-hopping.py <options>\n"
    print "Options:"
    print "-i <i>, --interface=<i>                  set interface (default: mon0)"
    print "-t <time>, --time=<time>                 scan time"
    print "-c <values>, --channel=<values>          list of channels to scan (default: 1,2,3,4,5,6,7,8,9,10,11,12)"
    print "-d <seconds> --delay=<seconds>           seconds between alerts"
    print "-h                                       Print this help message."
    print ""
    print "Author: xtr4nge"
    print ""

# MENU OPTIONS
def parseOptions(argv):
    INTERFACE = "mon0"
    TIME =  int(0)
    MONITOR = ""
    CHANNEL = "1,2,3,4,5,6,7,8,9,10,11,12"
    DELAY = 1

    try:
        opts, args = getopt.getopt(argv, "hi:t:c:d:",
                                   ["help", "interface=", "time=", "channel=", "delay="])

        for opt, arg in opts:
            if opt in ("-h", "--help"):
                usage()
                sys.exit()
            elif opt in ("-i", "--interface"):
                INTERFACE = arg
            elif opt in ("-t", "--time"):
                TIME = int(arg)
            elif opt in ("-c", "--channel"):
                CHANNEL = arg
            elif opt in ("-d", "--delay"):
                DELAY = int(arg)
        
        
        # CHANNEL INTO INT ARRAY
        TEMP = CHANNEL.split(",")
        CHANNEL = []
        for i in TEMP:
            CHANNEL.append(int(i))
        
        return (INTERFACE, TIME, CHANNEL, DELAY)
                    
    except getopt.GetoptError:           
        usage()
        sys.exit(2) 

# CHECKS TIME PASSED BETWEEN ALERTS
def checkDelay(FLAG, DELAY):
    NOW = int(time.time())
    FLAG = int(FLAG)

    if (FLAG + DELAY) < NOW:
        return True
    else:
        return False

# -------------------------
# GLOBAL VARIABLES
# -------------------------

(INTERFACE, TIME, CHANNEL, DELAY) = parseOptions(sys.argv[1:])


# Channel hopper - This code is very similar to that found in airoscapy.py (http://www.thesprawl.org/projects/airoscapy/)
def channel_hopper(interface):
    global CHANNEL
    global DELAY
    
    while True:
        try:
            #channel = random.randrange(1,13)
            channel = random.choice(CHANNEL)
            os.system("iwconfig %s channel %d" % (interface, channel))
            time.sleep(DELAY)
        except KeyboardInterrupt:
            break

def stop_channel_hop(signal, frame):
    # set the stop_sniff variable to True to stop the sniffer
    global stop_sniff
    stop_sniff = True
    channel_hop.terminate()
    channel_hop.join()


try:
    channel_hop = Process(target = channel_hopper, args=(INTERFACE,))
    channel_hop.start()
    signal.signal(signal.SIGINT, stop_channel_hop)
    
except Exception as e:
    print str(e)
    print sys.exc_info()[0]
    print "Bye ;)"
