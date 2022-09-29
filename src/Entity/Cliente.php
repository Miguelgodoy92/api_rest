<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClienteRepository::class)
 */
class Cliente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="integer")
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Cliente;

    /**
     * @ORM\OneToMany(targetEntity=Direccion::class, mappedBy="cliente", orphanRemoval=true)
     */
    private $direcciones;

    /**
     * @ORM\OneToMany(targetEntity=Pedido::class, mappedBy="cliente", orphanRemoval=true)
     */
    private $pedido;

    public function __construct()
    {
        $this->direcciones = new ArrayCollection();
        $this->pedido = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getCliente(): ?string
    {
        return $this->Cliente;
    }

    public function setCliente(string $Cliente): self
    {
        $this->Cliente = $Cliente;

        return $this;
    }

    /**
     * @return Collection<int, Direccion>
     */
    public function getDirecciones(): Collection
    {
        return $this->direcciones;
    }

    public function addDireccione(Direccion $direccione): self
    {
        if (!$this->direcciones->contains($direccione)) {
            $this->direcciones[] = $direccione;
            $direccione->setCliente($this);
        }

        return $this;
    }

    public function removeDireccione(Direccion $direccione): self
    {
        if ($this->direcciones->removeElement($direccione)) {
            // set the owning side to null (unless already changed)
            if ($direccione->getCliente() === $this) {
                $direccione->setCliente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pedido>
     */
    public function getPedido(): Collection
    {
        return $this->pedido;
    }

    public function addPedido(Pedido $pedido): self
    {
        if (!$this->pedido->contains($pedido)) {
            $this->pedido[] = $pedido;
            $pedido->setCliente($this);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): self
    {
        if ($this->pedido->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getCliente() === $this) {
                $pedido->setCliente(null);
            }
        }

        return $this;
    }
}