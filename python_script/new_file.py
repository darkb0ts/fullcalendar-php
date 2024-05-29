# from collections import deque
# from datetime import datetime

# now = datetime.now()

# current_time = now.strftime("%H:%M")
# print("Current Time =", current_time)


# from datetime import datetime, timedelta

# # Get the current time
# now = datetime.now()

# # Add 5 minutes to the current time
# new_time = now + timedelta(minutes=5)

# # Format the new time
# formatted_new_time = new_time.strftime("%H:%M")

# print("Current time:", now.strftime("%H:%M"))
# print("Time after 5 minutes:", formatted_new_time)


# queue = deque()
# queue.append(current_time)
# queue.append(2)
# queue.append(3)
# queue.popleft()
       
# print(queue[0]) 
# print(queue) 
# print(len(queue))             

stc= [1]
if stc is not None:
    print(1)
stc.insert(0,1)
stc.pop()
stc.insert(0,99)
print(stc)
