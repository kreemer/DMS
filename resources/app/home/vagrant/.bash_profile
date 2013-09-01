export CLICOLOR=1
export LSCOLORS=ExFxCxDxBxegedabagacad
# Custom bash prompt via kirsle.net/wizards/ps1.html
export PS1='\[$(tput bold)\]\[$(tput setaf 1)\][\u@\h] \[$(tput setaf 3)\]\W\[$(tput setaf 7)\] > \[$(tput sgr0)\]'

alias ls='ls -G'
if [ -f ~/.git_completion.bash ]; then
    . ~/.git_completion.bash
fi
if [ -f ~/.git_prompt.sh ]; then
    . ~/.git_prompt.sh
    export PS1='\[$(tput bold)\]\[$(tput setaf 1)\][\u@\h] \[$(tput setaf 3)\]\W\[$(tput setaf 7)\]$(__git_ps1 " (%s)") > \[$(tput sgr0)\]'
fi